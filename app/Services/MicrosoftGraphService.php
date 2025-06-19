<?php

namespace App\Services;

use Microsoft\Graph\Graph;

class MicrosoftGraphService
{
    protected $graph;

    /**
     * De constructor ontvangt de access token en stelt deze direct in op het Graph-object.
     */
    public function __construct(string $accessToken)
    {
        $this->graph = new Graph();
        $this->graph->setAccessToken($accessToken);
    }

    /**
     * Geeft het geconfigureerde Graph-object terug, klaar voor gebruik.
     */
    public function getGraph(): Graph
    {
        return $this->graph;
    }
}