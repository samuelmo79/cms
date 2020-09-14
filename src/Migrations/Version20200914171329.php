<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200914171329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE artigo (id INT AUTO_INCREMENT NOT NULL, categoria_id INT DEFAULT NULL, autor_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, conteudo LONGTEXT NOT NULL, status VARCHAR(1) NOT NULL, acessos INT DEFAULT NULL, imagem VARCHAR(255) DEFAULT NULL, data_cadastro DATETIME NOT NULL, data_atualizacao DATETIME DEFAULT NULL, INDEX IDX_A592883E3397707A (categoria_id), INDEX IDX_A592883E14D45BBE (autor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artigo ADD CONSTRAINT FK_A592883E3397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE artigo ADD CONSTRAINT FK_A592883E14D45BBE FOREIGN KEY (autor_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE artigo');
    }
}
