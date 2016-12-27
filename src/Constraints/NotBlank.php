<?php

namespace Constraints;

use Symfony\Component\Validator\Constraints\NotBlank as ParentContstraint;

class NotBlank extends ParentContstraint
{
    public $message = 'Reikšmė negali būti tuščia';
}
