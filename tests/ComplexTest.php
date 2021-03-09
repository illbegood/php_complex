<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ComplexTest extends TestCase
{

    public function testMulDiv()
    {
        $x = new Complex(1, 2);
        $y = new Complex(3, 4);
        $z = $x->mul($y)->div($x);
        $this->assertTrue($z->equals($y));
    }

    public function testConj(){
        $x = new Complex(1, 2);
        $y = new Complex(3, 4);

        $zl = $x->conj()->add($y->conj());
        $zr = $x->add($y)->conj();
        $this->assertTrue($zl->equals($zr));

        $zl = $x->conj()->sub($y->conj());
        $zr = $x->sub($y)->conj();
        $this->assertTrue($zl->equals($zr));

        $zl = $x->mul($y)->conj();
        $zr = $x->conj()->mul($y->conj());
        $this->assertTrue($zl->equals($zr));

        $zl = $x->div($y)->conj();
        $zr = $x->conj()->div($y->conj());
        $this->assertTrue($zl->equals($zr));
    }

    public function testMoivre()
    {
        $x = 1;
        $n = 100;
        $z = new Complex(cos($x), sin($x));
        $zn = new Complex(1, 0);
        for ($i = 0; $i < $n; ++$i)
            $zn = $zn->mul($z);
        $zn2 = new Complex(cos($n * $x), sin($n * $x));
        $this->assertTrue($zn->equals($zn2));
    }


}
