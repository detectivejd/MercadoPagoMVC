<?php
namespace App;
abstract class ModelChild extends Model {
    function __construct() {
        parent::__construct(true);
    }
}
