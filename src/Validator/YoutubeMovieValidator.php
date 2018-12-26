<?php

namespace App\Validator;

use App\Utils\Generic\UriServicesGeneric;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class YoutubeMovieValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        preg_match('/^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+/m', $value, $matchUrl);

        if (count($matchUrl) === 0) {
            $this->addViolation($value, $constraint);
        }

        if (!UriServicesGeneric::pingUri($matchUrl[0])) {
            $this->addViolation($value, $constraint);
        }
    }

    private function addViolation($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\YoutubeMovie */
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
