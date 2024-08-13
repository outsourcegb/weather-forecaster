<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240813054334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add values to the location table';
    }

    public function up(Schema $schema): void
    {
        // remove existing records from location table
        $this->addSql('DELETE FROM location');

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO location (name, country_code, latitude, longitude) VALUES (\'Paris\', \'FR\', \'48.8566\', \'2.3522\')');
        $this->addSql('INSERT INTO location (name, country_code, latitude, longitude) VALUES (\'London\', \'GB\', \'51.5074\', \'0.1278\')');
        $this->addSql('INSERT INTO location (name, country_code, latitude, longitude) VALUES (\'New York\', \'US\', \'40.7128\', \'74.0060\')');
        $this->addSql('INSERT INTO location (name, country_code, latitude, longitude) VALUES (\'San Francisco\', \'US\', \'37.7749\', \'122.4194\')');
        $this->addSql('INSERT INTO location (name, country_code, latitude, longitude) VALUES (\'Sydney\', \'AU\', \'33.8688\', \'151.2093\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM location WHERE name = \'Paris\'');
        $this->addSql('DELETE FROM location WHERE name = \'London\'');
        $this->addSql('DELETE FROM location WHERE name = \'New York\'');
        $this->addSql('DELETE FROM location WHERE name = \'San Francisco\'');
        $this->addSql('DELETE FROM location WHERE name = \'Sydney\'');
    }
}
