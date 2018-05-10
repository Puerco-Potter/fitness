<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180510132037 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ficha_medica (id INT AUTO_INCREMENT NOT NULL, enfermedades_cardiacas TINYINT(1) DEFAULT NULL, lesiones_cronicas TINYINT(1) DEFAULT NULL, rehabilitacion TINYINT(1) DEFAULT NULL, perder_peso TINYINT(1) DEFAULT NULL, diabetes TINYINT(1) NOT NULL, cirugia TINYINT(1) NOT NULL, dieta TINYINT(1) NOT NULL, problemas_articulares TINYINT(1) NOT NULL, dolores TINYINT(1) NOT NULL, problemas_espalda TINYINT(1) NOT NULL, sobrepeso TINYINT(1) NOT NULL, hipertension TINYINT(1) NOT NULL, medicamentos TINYINT(1) NOT NULL, embarazo TINYINT(1) NOT NULL, hernias TINYINT(1) NOT NULL, hidratado TINYINT(1) NOT NULL, peso DOUBLE PRECISION DEFAULT NULL, altura DOUBLE PRECISION DEFAULT NULL, talla LONGTEXT DEFAULT NULL, observaciones LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ficha_medica');
    }
}
