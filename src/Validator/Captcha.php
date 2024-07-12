<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
class Captcha extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public string $invalidCaptcha = 'Captcha invalide';

    public string $emptyResponse = 'Veuillez remplir le captcha';

    public string $notAllowedToConnect = "Vous n'êtes pas autorisé à vous connecter à l'API";
}
