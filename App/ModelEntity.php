<?php
namespace App;
abstract class ModelEntity extends Model {
    function __construct() {
        parent::__construct(false);
    }
}
