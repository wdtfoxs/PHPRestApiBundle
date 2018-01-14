<?php
/**
 * Created by PhpStorm.
 * User: wdtfoxs
 * Date: 14.01.18
 * Time: 1:02
 */


namespace RestApiBundle\Interfaces;


interface RestApiService
{

    function findAll();

    function find($id);

    function deleteAll();

    function delete($id);

    function update($id, $object);

    function save($object);
}