<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190121135946 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE news (idNews INT UNSIGNED AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, short_description TEXT NOT NULL, description TEXT NOT NULL, posted_at DATETIME NOT NULL, author VARCHAR(100) NOT NULL, PRIMARY KEY(idNews)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE country CHANGE idCountry idCountry VARCHAR(2) NOT NULL');
        $this->addSql('ALTER TABLE genre MODIFY idGenre INT UNSIGNED NOT NULL');
        $this->addSql('DROP INDEX unique_name ON genre');
        $this->addSql('ALTER TABLE genre DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE genre ADD PRIMARY KEY (idGenre)');
        $this->addSql('ALTER TABLE premiere CHANGE idCountry idCountry VARCHAR(2) DEFAULT NULL');
        $this->addSql('ALTER TABLE production CHANGE type type INT UNSIGNED DEFAULT NULL');
        $this->addSql('DROP INDEX productionactor_index ON productionactor');
        $this->addSql('DROP INDEX productioncountry_index ON productioncountry');
        $this->addSql('DROP INDEX productiondirector_index ON productiondirector');
        $this->addSql('DROP INDEX productiongenre_index ON productiongenre');
        $this->addSql('DROP INDEX productionpremiere_index ON productionpremiere');
        $this->addSql('DROP INDEX productionproducer_index ON productionproducer');
        $this->addSql('DROP INDEX productionscenarist_index ON productionscenarist');
        $this->addSql('ALTER TABLE rating MODIFY idRating INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE rating DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE rating CHANGE idRating idRating INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD PRIMARY KEY (idProduction, idUser)');
        $this->addSql('ALTER TABLE user CHANGE roles roles TINYTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE news');
        $this->addSql('ALTER TABLE country CHANGE idCountry idCountry VARCHAR(2) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE genre MODIFY idGenre INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE genre DROP PRIMARY KEY');
        $this->addSql('CREATE UNIQUE INDEX unique_name ON genre (name)');
        $this->addSql('ALTER TABLE genre ADD PRIMARY KEY (idGenre, name)');
        $this->addSql('ALTER TABLE premiere CHANGE idCountry idCountry VARCHAR(2) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE production CHANGE type type INT UNSIGNED NOT NULL');
        $this->addSql('CREATE INDEX productionactor_index ON productionactor (idPersonForActror, idProductionForActor)');
        $this->addSql('CREATE INDEX productioncountry_index ON productioncountry (idCountry, idProduction)');
        $this->addSql('CREATE INDEX productiondirector_index ON productiondirector (idPersonForDirector, idProductionForDirector)');
        $this->addSql('CREATE INDEX productiongenre_index ON productiongenre (idGenre, idProduction)');
        $this->addSql('CREATE INDEX productionpremiere_index ON productionpremiere (idPremiere, idProduction)');
        $this->addSql('CREATE INDEX productionproducer_index ON productionproducer (idPersonForProducer, idProductionForProducer)');
        $this->addSql('CREATE INDEX productionscenarist_index ON productionscenarist (idPersonForScenarist, idProductionForScenarist)');
        $this->addSql('ALTER TABLE rating DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE rating CHANGE idRating idRating INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE rating ADD PRIMARY KEY (idRating)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(255) NOT NULL COLLATE utf8_general_ci');
    }
}
