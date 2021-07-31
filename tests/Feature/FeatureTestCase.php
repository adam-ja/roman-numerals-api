<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
}
