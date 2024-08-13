<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240813092925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create forcasts for available locations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        // delete all existing forecasts
        $this->addSql('DELETE FROM forecast');

        // get all locations and create 2 forecasts for each location
        $this->addSql('INSERT INTO forecast (location_id, date, celsius) SELECT id, "2024-08-13", 20 FROM location');
        $this->addSql('INSERT INTO forecast (location_id, date, celsius) SELECT id, "2024-08-14", 21 FROM location');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM forecast');
    }
}
