<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504115246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE telecharger DROP FOREIGN KEY FK_E06A3C34F915CFE');
        $this->addSql('DROP INDEX IDX_E06A3C34F915CFE ON telecharger');
        $this->addSql('ALTER TABLE telecharger DROP fichier_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE telecharger ADD fichier_id INT NOT NULL');
        $this->addSql('ALTER TABLE telecharger ADD CONSTRAINT FK_E06A3C34F915CFE FOREIGN KEY (fichier_id) REFERENCES fichier (id)');
        $this->addSql('CREATE INDEX IDX_E06A3C34F915CFE ON telecharger (fichier_id)');
    }
}
