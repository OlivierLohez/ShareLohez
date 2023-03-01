<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504114955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fichier_fichier (fichier_source INT NOT NULL, fichier_target INT NOT NULL, INDEX IDX_40E5A92877BF9E59 (fichier_source), INDEX IDX_40E5A9286E5ACED6 (fichier_target), PRIMARY KEY(fichier_source, fichier_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier_user (fichier_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C1C1EA2F915CFE (fichier_id), INDEX IDX_C1C1EA2A76ED395 (user_id), PRIMARY KEY(fichier_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telecharger (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, fichier_id INT NOT NULL, nb INT NOT NULL, INDEX IDX_E06A3C34A76ED395 (user_id), INDEX IDX_E06A3C34F915CFE (fichier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fichier_fichier ADD CONSTRAINT FK_40E5A92877BF9E59 FOREIGN KEY (fichier_source) REFERENCES fichier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fichier_fichier ADD CONSTRAINT FK_40E5A9286E5ACED6 FOREIGN KEY (fichier_target) REFERENCES fichier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fichier_user ADD CONSTRAINT FK_C1C1EA2F915CFE FOREIGN KEY (fichier_id) REFERENCES fichier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fichier_user ADD CONSTRAINT FK_C1C1EA2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE telecharger ADD CONSTRAINT FK_E06A3C34A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE telecharger ADD CONSTRAINT FK_E06A3C34F915CFE FOREIGN KEY (fichier_id) REFERENCES fichier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fichier_fichier');
        $this->addSql('DROP TABLE fichier_user');
        $this->addSql('DROP TABLE telecharger');
    }
}
