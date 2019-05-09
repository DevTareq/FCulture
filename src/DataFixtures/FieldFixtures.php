<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\FieldPasswordEncoderInterface;
use App\Entity\Field;

class FieldFixtures extends Fixture
{
    private $data = [];
    private $file = "src/DataFixtures/field.csv";

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->parseCSV();
        echo count($this->data) . " fields parsed \n\r";

        $this->generateEntities();
    }

    private function generateEntities()
    {
        foreach ($this->data as $data) {
            $object = new Field();

            $object->setName($data[0]);
            $object->setArea(rand(10, 50) * 100);

            // Persist
            $this->saveObject($object);
        }
    }

    public function saveObject(&$object)
    {
        $this->manager->persist($object);
        $this->manager->flush();

        return $object;
    }

    public function parseCSV()
    {
        $rows = [];

        $row = 1;
        if (($handle = $this->utf8_fopen_read($this->file)) !== false) {
            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                if ($row != 1) {
                    $rows[] = $data;
                }
                $row++;
            }
            fclose($handle);
        }

        $this->data = $rows;
    }

    public function utf8_fopen_read($fileName)
    {
        $fc     = file_get_contents($fileName);
        $handle = fopen("php://memory", "rw");
        fwrite($handle, $fc);
        fseek($handle, 0);

        return $handle;
    }
}
