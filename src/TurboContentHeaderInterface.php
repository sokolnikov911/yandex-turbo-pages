<?php

namespace sokolnikov911\YandexTurboPages;


interface TurboContentHeaderInterface
{
    /**
     * Set header h1 title
     * @param string $titleH1
     * @return TurboContentHeaderInterface
     */
    public function titleH1(string $titleH1): TurboContentHeaderInterface;

    /**
     * Set header h2 title
     * @param string $titleH2
     * @return TurboContentHeaderInterface
     */
    public function titleH2(string $titleH2): TurboContentHeaderInterface;

    /**
     * Set header image url
     * @param string $img
     * @return TurboContentHeaderInterface
     */
    public function img(string $img): TurboContentHeaderInterface;

    /**
     * Return header as HTML
     * @return string
     */
    public function asHTML(): string;
}