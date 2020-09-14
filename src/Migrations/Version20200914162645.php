<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200914162645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(20) NOT NULL, slug VARCHAR(30) NOT NULL, data_cadastro DATETIME NOT NULL, data_atualizacao DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE categoria');
    }

    public function postUp(Schema $schema) : void
    {
        $this->write('Inserindo categorias padrão.');
        $contaCategoria = (int)$this->connection->fetchColumn('select count(*) from categoria');
        $data = date('Y-m-d H:i:s');
        if ($contaCategoria == 0) {
            $numberAffectedRows = $this->connection->insert('categoria', [
                'id' => 1,
                'nome' => 'Default',
                'slug' => 'default',
                'data_cadastro' => $data,
            ]);
            $success = $numberAffectedRows > 0;
            $this->warnIf(!$success, 'Houve um erro ao inserir as categorias.');
            if ($success) {
                $output = new ConsoleOutput();

                $texto = "\n";
                $texto .= "*******************************************************************************************\n";
                $texto .= "Categoria padrão inserida com sucesso!\n";
                $texto .= "Obs.: Vá até o painel admin para cadastrar outras categorias.\n";
                $texto .= "*******************************************************************************************";

                $output->writeln('<fg=black;bg=cyan>'.$texto.'</>');
            }
        }
    }
}
