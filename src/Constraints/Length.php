<?php

namespace Constraints;

use Symfony\Component\Validator\Constraints\Length as ParentContstraint;

class Length extends ParentContstraint
{
    public $maxMessage = 'Reikšmė per ilga. Turi tūrėti mažiau nei {{ limit }} simbolius';
    public $minMessage = 'Reikšmė per trumpa. Turi tūrėti daugiau nei {{ limit }} simbolius';
}
