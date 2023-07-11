<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230707225531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pagos (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, mes DATE NOT NULL, INDEX IDX_DA9B0DFFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_categoria (id INT AUTO_INCREMENT NOT NULL, video_id_id INT NOT NULL, categoria_id_id INT NOT NULL, UNIQUE INDEX UNIQ_8C6F6FB8F02697F5 (video_id_id), UNIQUE INDEX UNIQ_8C6F6FB87E735794 (categoria_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pagos ADD CONSTRAINT FK_DA9B0DFFA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE video_categoria ADD CONSTRAINT FK_8C6F6FB8F02697F5 FOREIGN KEY (video_id_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE video_categoria ADD CONSTRAINT FK_8C6F6FB87E735794 FOREIGN KEY (categoria_id_id) REFERENCES categoria (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pagos DROP FOREIGN KEY FK_DA9B0DFFA76ED395');
        $this->addSql('ALTER TABLE video_categoria DROP FOREIGN KEY FK_8C6F6FB8F02697F5');
        $this->addSql('ALTER TABLE video_categoria DROP FOREIGN KEY FK_8C6F6FB87E735794');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE pagos');
        $this->addSql('DROP TABLE video_categoria');
    }
}
