<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180424074704 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE attachment (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, make VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, trip_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, gender TINYINT(1) NOT NULL, INDEX IDX_C7440455A5BC2E0E (trip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE driver (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, license VARCHAR(255) NOT NULL, age INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE driver_car (driver_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_65F67493C3423909 (driver_id), INDEX IDX_65F67493C3C6F69F (car_id), PRIMARY KEY(driver_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, driver_id INT DEFAULT NULL, length DOUBLE PRECISION NOT NULL, duration INT NOT NULL, cost DOUBLE PRECISION NOT NULL, INDEX IDX_7656F53BC3C6F69F (car_id), INDEX IDX_7656F53BC3423909 (driver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE driver_car ADD CONSTRAINT FK_65F67493C3423909 FOREIGN KEY (driver_id) REFERENCES driver (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE driver_car ADD CONSTRAINT FK_65F67493C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BC3423909 FOREIGN KEY (driver_id) REFERENCES driver (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE driver_car DROP FOREIGN KEY FK_65F67493C3C6F69F');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BC3C6F69F');
        $this->addSql('ALTER TABLE driver_car DROP FOREIGN KEY FK_65F67493C3423909');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BC3423909');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A5BC2E0E');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE driver');
        $this->addSql('DROP TABLE driver_car');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE users');
    }
}
