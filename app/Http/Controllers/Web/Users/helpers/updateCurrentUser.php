<?php

namespace App\Http\Controllers\Web\Users\helpers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Services\BackupService;
use App\Models\SystemPermission;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;



class updateCurrentUser
{

    private static UserRequest $user_request;
    private static array $user_form_fields;

    private static User $user;

    private static bool $isBackupCreated = false;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if(static::$user->id !== auth()->user()->id) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de modifier les informations personnelle d un autre utilisateur"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function preparingUser(): void
    {
        $original_data = static::$user->getOriginal();

        foreach (static::$user_form_fields as $key => $value) {
            if (array_key_exists($key, $original_data)) {
                if ($value === null || $value == $original_data[$key]) {
                    unset(static::$user_form_fields[$key]);
                }
            }
        }

        if(isset(static::$user_form_fields["password"])) {
            static::$user_form_fields["password"] = Hash::make(static::$user_form_fields["password"]);
        }
    }


    private static function updateUserImage(): void
    {
        if (static::$user_request->hasFile('user_image')) {

            if (!BackupService::createImagesBackup("users", static::$user->id)) {
                static::$isBackupCreated = false;
                throw new \Exception("échec de crée une sauvgarde pour les images");
            }

            static::$isBackupCreated = true;

            if (!unlink(storage_path('app/public/' . static::$user->image_path))) {
                throw new \Exception("échec de supprimer l'ancienne image dans le dossier users");
            }

            $imageFile = static::$user_request->file('user_image');
            $folderPath = 'users/id_' . static::$user->id;
            static::$user_form_fields["image_path"] = $imageFile->store($folderPath, 'public');
            if (!static::$user_form_fields["image_path"]) {
                throw new \Exception("échec de stocké la nouvelle image dans le dossier users");
            }

            unset(static::$user_form_fields["user_image"]);
        }
    }


    private static function updateUser(): void
    {
        static::updateUserImage();

        if (!static::$user->update(static::$user_form_fields)) {
            throw new \Exception("échec de mis à jour l'enregistrement dans la table 'users'");
        }

        BackupService::deleteImagesBackup("users", static::$user->id);

    }


    private static function makeUpdate(): RedirectResponse
    {
        if (
            count(static::$user_form_fields) !== 0 ||
            static::$user_request->hasFile('user_image')
        ) {
            try {
                DB::transaction(function () {
                    static::updateUser();
                });

                $message = [
                    "type" => "success",
                    "text" => "l utilisateur est bien modifiée."
                ];
            } catch (\Exception $th) {

                if (static::$isBackupCreated) {
                    /*
                        la question que j'ai pas trouvé encore de réponse c'est que si par exemple meme la restoration n'est pas aussi réussi. est ce que je fais un autre block catch !!
                    */
                    BackupService::makeImagesRestoration("users", static::$user->id);
                }

                $message = [
                    "type" => "danger",
                    "text" => "la modification d utilisateur a échoué. Réessayer plus tard",
                    "error" => $th->getMessage(),
                    "file" => $th->getFile(),
                    "line" => $th->getLine()
                ];
            } finally {
                return back()->with("message", $message);
            }
        } else {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez rien modifier !"
            ];
            return back()->with("message", $message);
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(User $user, UserRequest $user_request): RedirectResponse
    {

        static::$user_request = $user_request;

        static::$user = $user;

        static::$user_form_fields = static::$user_request->validated();

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        static::preparingUser();

        return static::makeUpdate();
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
