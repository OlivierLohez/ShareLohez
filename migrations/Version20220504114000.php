<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504114000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accepter DROP FOREIGN KEY FK_82C9431F953C1C61');
        $this->addSql('DROP INDEX IDX_82C9431F953C1C61 ON accepter');
        $this->addSql('ALTER TABLE accepter DROP source_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accepter ADD source_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accepter ADD CONSTRAINT FK_82C9431F953C1C61 FOREIGN KEY (source_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_82C9431F953C1C61 ON accepter (source_id)');
    }
}
