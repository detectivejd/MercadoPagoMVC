<?php
namespace App;
interface IPersiste {
    function create();
    function update();
    function delete();
    function find($params = []);
    function findById($params = []);
    function findBy($field, $params = []);
    function addChild($object);
    function modChild($object);
    function delChild($object);    
    function getChild($hijo, $params = []);
    function getChildren($hijo);
}