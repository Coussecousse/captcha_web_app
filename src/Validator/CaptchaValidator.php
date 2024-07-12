<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CaptchaValidator extends ConstraintValidator
{
    public function __construct(
        private readonly HttpClientInterface $httpClient
        )
    {
        
    }

    /**
     * 
     * @params array{challenge: string, answer: string} $value
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        // Check if we can connect to the api
        $ConnectionnLink = 'http://127.0.0.1:8000/captcha/connect?user_key=' . $value['user_key'];

        $response = $this->httpClient->request('GET', $ConnectionnLink);
        $response = $response->toArray();

        if (!$response['valid']) {
            $this->context->buildViolation($constraint->notAllowedToConnect)
                ->addViolation();
                return;
        }

        // Check if the value isn't blank
        foreach($value as $val) {
            if (null === $val || '' === $val) {
                $this->context->buildViolation($constraint->emptyResponse)
                ->addViolation();
                return;
            }
        }

        foreach($value as $key => $val) {
            if (str_starts_with($key, 'answer_')) {
                $answers[] = $val;
            }
        }

        $params = [
            'key' => $value['key'],
            'answers' => $answers
        ];
        $link = 'http://127.0.0.1:8000/captcha/verify?' . http_build_query($params);

        $response = $this->httpClient->request('GET', $link);
        $response = $response->toArray();

        if (!$response['valid']) {
            $this->context->buildViolation($constraint->invalidCaptcha)
                ->addViolation();
        }

    }
}
