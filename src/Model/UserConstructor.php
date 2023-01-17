<?php

namespace Blog\Model;

use Blog\Entity\User;
use Blog\Exception\FormException;

class UserConstructor
{
    private User $user;
    public function __construct($form)
    {
        $this->user =new User;
        $methodsettings = "Set";
        //this is probably not usefull as it is already checked client side but never trust the client side
        $this->verifyRequired($form);
        foreach ($form as $fieldKey => $fieldValue) {
            //TODO make fieldkey matches userfield array
            if (!empty($fieldValue)&&$fieldKey!=='passwordverify') {
                if($fieldKey==='role'){
                    $fieldValue = $fieldValue=='user'?0:1;
                }
                $method = $methodsettings . \ucfirst($fieldKey);
                $this->user->$method($fieldValue);
            }
        }
    }
    public function getUser(){
        return $this->user;
    }

    private function verifyRequired(array $form): void
    {
        if (!empty($form['username'])) {
            throw new FormException('le nom d\'utilisateur n\'ai pas rempli');
        }
        if (empty($form['password']) || empty($form['passwordverify'])) {
            throw new FormException('le mot de passe n\'ai pas rempli');
        }
        if (!($form['password'] === $form['passwordverify'])) {
            throw new FormException('les deux mots de passe ne corresponde pas');
        }
        if (empty($form['mail'])) {
            throw new FormException('le mail ne convient pas');
        }
    }
}
