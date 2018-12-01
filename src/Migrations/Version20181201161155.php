<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181201161155 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, artist_id_id INT NOT NULL, token_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_39986E431F48AE04 (artist_id_id), UNIQUE INDEX UNIQ_39986E43DC9A9A16 (token_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, token_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1599687DC9A9A16 (token_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, album_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, length INT NOT NULL, UNIQUE INDEX UNIQ_33EDEEA19FCD471 (album_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(6) NOT NULL, UNIQUE INDEX UNIQ_5F37A13B1D775834 (value), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E431F48AE04 FOREIGN KEY (artist_id_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43DC9A9A16 FOREIGN KEY (token_id_id) REFERENCES token (id)');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_1599687DC9A9A16 FOREIGN KEY (token_id_id) REFERENCES token (id)');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA19FCD471 FOREIGN KEY (album_id_id) REFERENCES album (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA19FCD471');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E431F48AE04');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43DC9A9A16');
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_1599687DC9A9A16');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE token');
    }
}
