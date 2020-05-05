<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200505143011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE47725F7B143');
        $this->addSql('DROP INDEX IDX_5E3DE47725F7B143 ON skill');
        $this->addSql('ALTER TABLE skill CHANGE technos_id techno_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE47751F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE47751F3C1BC ON skill (techno_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE47751F3C1BC');
        $this->addSql('DROP INDEX IDX_5E3DE47751F3C1BC ON skill');
        $this->addSql('ALTER TABLE skill CHANGE techno_id technos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE47725F7B143 FOREIGN KEY (technos_id) REFERENCES techno (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE47725F7B143 ON skill (technos_id)');
    }
}
