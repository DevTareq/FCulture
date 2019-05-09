<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190508221254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE field_processing (id INT AUTO_INCREMENT NOT NULL, tractor_id INT NOT NULL, field_id INT NOT NULL, crop_id INT NOT NULL, user_id INT DEFAULT NULL, date DATETIME NOT NULL, area INT NOT NULL, INDEX IDX_85E4C293B7858BE4 (tractor_id), INDEX IDX_85E4C293443707B0 (field_id), INDEX IDX_85E4C293888579EE (crop_id), INDEX IDX_85E4C293A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, is_active TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, area INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tractor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE field_processing ADD CONSTRAINT FK_85E4C293B7858BE4 FOREIGN KEY (tractor_id) REFERENCES tractor (id)');
        $this->addSql('ALTER TABLE field_processing ADD CONSTRAINT FK_85E4C293443707B0 FOREIGN KEY (field_id) REFERENCES field (id)');
        $this->addSql('ALTER TABLE field_processing ADD CONSTRAINT FK_85E4C293888579EE FOREIGN KEY (crop_id) REFERENCES crop (id)');
        $this->addSql('ALTER TABLE field_processing ADD CONSTRAINT FK_85E4C293A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE field_processing DROP FOREIGN KEY FK_85E4C293888579EE');
        $this->addSql('ALTER TABLE field_processing DROP FOREIGN KEY FK_85E4C293A76ED395');
        $this->addSql('ALTER TABLE field_processing DROP FOREIGN KEY FK_85E4C293443707B0');
        $this->addSql('ALTER TABLE field_processing DROP FOREIGN KEY FK_85E4C293B7858BE4');
        $this->addSql('DROP TABLE field_processing');
        $this->addSql('DROP TABLE crop');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE field');
        $this->addSql('DROP TABLE tractor');
    }
}
