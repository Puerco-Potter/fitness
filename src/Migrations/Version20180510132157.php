<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180510132157 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ficha_medica CHANGE enfermedades_cardiacas enfermedades_cardiacas TINYINT(1) NOT NULL, CHANGE lesiones_cronicas lesiones_cronicas TINYINT(1) NOT NULL, CHANGE rehabilitacion rehabilitacion TINYINT(1) NOT NULL, CHANGE perder_peso perder_peso TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ficha_medica CHANGE enfermedades_cardiacas enfermedades_cardiacas TINYINT(1) DEFAULT NULL, CHANGE lesiones_cronicas lesiones_cronicas TINYINT(1) DEFAULT NULL, CHANGE rehabilitacion rehabilitacion TINYINT(1) DEFAULT NULL, CHANGE perder_peso perder_peso TINYINT(1) DEFAULT NULL');
    }
}
