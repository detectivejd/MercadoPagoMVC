<?php
namespace App;
interface IModel {
    function create($object);
    function update($object);
    function delete($object);
    function find($params = []);
    function findById($params = []);
    function findBy($field, $params = []);
    function addChild($object, $child);
    function modChild($object, $child);
    function delChild($object, $child);
    function getChild($hijo, $params = []);    
    function getChildren($hijo, $object);
}
