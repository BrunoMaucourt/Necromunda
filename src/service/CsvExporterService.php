<?php
namespace App\service;

use App\Enum\GangerTypeEnum;
use App\Enum\HouseEnum;
use App\Enum\ScenariosEnum;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\ExporterConfig;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
class CsvExporterService
{
    public function createResponseFromQueryBuilder(QueryBuilder $queryBuilder, FieldCollection $fields, string $filename): Response
    {
        $result = $queryBuilder->getQuery()->getArrayResult();
        $data = [];
        foreach ($result as $index => $row) {
            foreach ($row as $columnKey => $columnValue) {
                if (
                    $columnValue instanceof HouseEnum ||
                    $columnValue instanceof GangerTypeEnum ||
                    $columnValue instanceof ScenariosEnum
                ) {
                    $data[$index][$columnKey] = $columnValue->enumToString();
                } elseif ($row[$index][$columnKey] = $columnValue instanceof \DateTimeInterface) {
                    $data[$index][$columnKey] = $columnValue->format('Y-m-d H:i:s');
                } else {
                    $data[$index][$columnKey] = $columnValue;
                }
            }
        }

        // Humanize headers based on column labels in EA
        if (isset($data[0])) {
            $headers = [];
            $properties = array_keys($data[0]);
            foreach ($properties as $property) {
                $headers[$property] = ucfirst($property);
                foreach ($fields as $field) {
                    // Override property name if a custom label was set
                    if ($property === $field->getProperty() && $field->getLabel()) {
                        $headers[$property] = $field->getLabel();
                        // And stop iterating
                        break;
                    }
                }
            }
            // Add headers to the final data array
            array_unshift($data, $headers);
        }
        $response = new StreamedResponse(function () use ($data) {
            $config = new ExporterConfig();
            $exporter = new Exporter($config);
            $exporter->export('php://output', $data);
        });
        $dispositionHeader = $response->headers->makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $filename
        );
        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        return $response;
    }
}