<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180510134448 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ficha_medica ADD cliente_id INT NOT NULL');
        $this->addSql('ALTER TABLE ficha_medica ADD CONSTRAINT FK_E10B1F66DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('CREATE INDEX IDX_E10B1F66DE734E51 ON ficha_medica (cliente_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ficha_medica DROP FOREIGN KEY FK_E10B1F66DE734E51');
        $this->addSql('DROP INDEX IDX_E10B1F66DE734E51 ON ficha_medica');
        $this->addSql('ALTER TABLE ficha_medica DROP cliente_id');
    }
}
