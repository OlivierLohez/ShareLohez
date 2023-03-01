<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504113547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accepter DROP FOREIGN KEY FK_82C9431FE64C4568');
        $this->addSql('DROP INDEX IDX_82C9431FE64C4568 ON accepter');
        $this->addSql('ALTER TABLE accepter DROP source_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accepter ADD source_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE accepter ADD CONSTRAINT FK_82C9431FE64C4568 FOREIGN KEY (source_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_82C9431FE64C4568 ON accepter (source_id_id)');
    }
}
