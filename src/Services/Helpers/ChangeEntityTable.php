<?php


namespace App\Services\Helpers;


class ChangeEntityTable
{

    public static function change(
        $tableName,
        $entityManager,
        $EntityName
    ) {
        $metadata = $entityManager->getClassMetadata('App:DataTable');
        $metadata->setPrimaryTable(array('name' => $tableName));

        return $entityManager->getRepository('App:'.$EntityName);
    }

}