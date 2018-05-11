<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180511150314 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, dni INT NOT NULL, nombre LONGTEXT DEFAULT NULL, apellido LONGTEXT DEFAULT NULL, direccion LONGTEXT DEFAULT NULL, localidad LONGTEXT DEFAULT NULL, telefono INT DEFAULT NULL, correo LONGTEXT DEFAULT NULL, fecha_nacimiento DATE DEFAULT NULL, cuenta DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ficha_medica (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, enfermedades_cardiacas TINYINT(1) NOT NULL, lesiones_cronicas TINYINT(1) NOT NULL, rehabilitacion TINYINT(1) NOT NULL, perder_peso TINYINT(1) NOT NULL, diabetes TINYINT(1) NOT NULL, cirugia TINYINT(1) NOT NULL, dieta TINYINT(1) NOT NULL, problemas_articulares TINYINT(1) NOT NULL, dolores TINYINT(1) NOT NULL, problemas_espalda TINYINT(1) NOT NULL, sobrepeso TINYINT(1) NOT NULL, hipertension TINYINT(1) NOT NULL, medicamentos TINYINT(1) NOT NULL, embarazo TINYINT(1) NOT NULL, hernias TINYINT(1) NOT NULL, hidratado TINYINT(1) NOT NULL, peso DOUBLE PRECISION DEFAULT NULL, altura DOUBLE PRECISION DEFAULT NULL, talla LONGTEXT DEFAULT NULL, observaciones LONGTEXT DEFAULT NULL, INDEX IDX_E10B1F66DE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_C2502824F85E0677 (username), UNIQUE INDEX UNIQ_C2502824E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ficha_medica ADD CONSTRAINT FK_E10B1F66DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ficha_medica DROP FOREIGN KEY FK_E10B1F66DE734E51');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE ficha_medica');
        $this->addSql('DROP TABLE app_users');
    }
}
