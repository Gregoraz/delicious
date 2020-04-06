<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200406163931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE userfavrestaurant CHANGE userID userID INT DEFAULT NULL, CHANGE restaurantID restaurantID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menuitem CHANGE restaurantID restaurantID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE salt salt VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON DEFAULT NULL, CHANGE hasRestaurant hasRestaurant VARCHAR(10) DEFAULT NULL, CHANGE restaurantID restaurantID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant CHANGE cuisineID cuisineID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuisine CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cuisine CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE menuitem CHANGE restaurantID restaurantID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant CHANGE cuisineID cuisineID INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE salt salt VARCHAR(255) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE roles roles VARCHAR(255) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE hasRestaurant hasRestaurant VARCHAR(10) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE restaurantID restaurantID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE userfavrestaurant CHANGE userID userID INT DEFAULT NULL, CHANGE restaurantID restaurantID INT DEFAULT NULL');
    }
}
