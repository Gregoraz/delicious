<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200406163804 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_fav_restaurant (restaurant_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_356A1665B1E7706E (restaurant_id), INDEX IDX_356A1665A76ED395 (user_id), PRIMARY KEY(restaurant_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_fav_restaurant ADD CONSTRAINT FK_356A1665B1E7706E FOREIGN KEY (restaurant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_fav_restaurant ADD CONSTRAINT FK_356A1665A76ED395 FOREIGN KEY (user_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE userfavrestaurant CHANGE userID userID INT DEFAULT NULL, CHANGE restaurantID restaurantID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menuitem CHANGE restaurantID restaurantID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE salt salt VARCHAR(255) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE restaurantID restaurantID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant CHANGE cuisineID cuisineID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuisine CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_fav_restaurant');
        $this->addSql('ALTER TABLE cuisine CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE menuitem CHANGE restaurantID restaurantID INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant CHANGE cuisineID cuisineID INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE salt salt VARCHAR(255) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE roles roles VARCHAR(255) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE restaurantID restaurantID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE userfavrestaurant CHANGE userID userID INT NOT NULL, CHANGE restaurantID restaurantID INT NOT NULL');
    }
}
