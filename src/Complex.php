<?php declare(strict_types=1);

class Complex{
    const delta = 1e-7;
    private bool $isNan, $isInf, $isZero;

    /**
     * @return bool
     */
    public function isZero(): bool
    {
        return $this->isZero;
    }

    /**
     * @return bool
     */
    public function isNan(): bool
    {
        return $this->isNan;
    }

    /**
     * @return bool
     */
    public function isInf(): bool
    {
        return $this->isInf;
    }
    /**
     * @return float
     */

    private float $re, $im;

    public function __construct(float $re, float $im)
    {
        $this->re = $re;
        $this->im = $im;
        $this->isNan = is_nan($this->re) || is_nan($this->im);
        $this->isInf = is_infinite($this->re) || is_infinite($this->im);
        $this->isZero = $this->mod2() ** 0.5 <= self::delta;
    }

    public function equals(Complex $other): bool
    {
        return $this->sub($other)->isZero();
    }

    public static function nan(): Complex
    {
        return new Complex(NAN, NAN);
    }

    public static function inf(): Complex
    {
        return new Complex(INF, INF);
    }

    public static function zero(): Complex
    {
        return new Complex(0, 0);
    }

    public function conj(): Complex
    {
        return new Complex($this->re, -$this->im);
    }

    public function mod2(): float
    {
        return $this->re ** 2 + $this->im ** 2;
    }

    public function add(Complex $other): Complex
    {
        return new Complex($this->re + $other->re, $this->im + $other->im);
    }

    public function sub(Complex $other): Complex
    {
        return new Complex($this->re - $other->re, $this->im - $other->im);
    }

    public function mul(Complex $other): Complex
    {
        if ($this->isNan() or $other->isNan()) return self::nan();
        if ($this->isInf() and $other->isZero()) return self::nan();
        if ($other->isInf() and $this->isZero()) return self::nan();
        if ($this->isInf() || $other->isInf()) return self::inf();
        $re = $this->re * $other->re - $this->im * $other->im;
        $im = $this->re * $other->im + $this->im * $other->re;
        return new Complex($re, $im);
    }

    public function div(Complex $other): Complex
    {
        if ($other->isZero()) return self::nan();
        if ($this->isNan() or $other->isNan()) return self::nan();
        if ($this->isInf() and $other->isInf()) return self::nan();
        if (!$this->isInf() and $other->isInf()) return self::zero();
        if ($this->isInf() and !$other->isInf()) return self::inf();
        $mod2 = $other->mod2();
        $ret = $this->mul($other->conj());
        $ret->re /= $mod2;
        $ret->im /= $mod2;
        return $ret;
    }
}
