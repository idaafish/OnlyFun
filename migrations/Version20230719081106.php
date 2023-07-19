<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719081106 extends AbstractMigration
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
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(150) NOT NULL, usuario VARCHAR(150) NOT NULL, password VARCHAR(150) NOT NULL, fecha DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(150) NOT NULL, url VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_categoria (id INT AUTO_INCREMENT NOT NULL, video_id INT NOT NULL, categoria_id INT NOT NULL, INDEX IDX_8C6F6FB829C1004E (video_id), INDEX IDX_8C6F6FB83397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_user (id INT AUTO_INCREMENT NOT NULL, video_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8A048B9529C1004E (video_id), INDEX IDX_8A048B95A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pagos ADD CONSTRAINT FK_DA9B0DFFA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE video_categoria ADD CONSTRAINT FK_8C6F6FB829C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE video_categoria ADD CONSTRAINT FK_8C6F6FB83397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE video_user ADD CONSTRAINT FK_8A048B9529C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE video_user ADD CONSTRAINT FK_8A048B95A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pagos DROP FOREIGN KEY FK_DA9B0DFFA76ED395');
        $this->addSql('ALTER TABLE video_categoria DROP FOREIGN KEY FK_8C6F6FB829C1004E');
        $this->addSql('ALTER TABLE video_categoria DROP FOREIGN KEY FK_8C6F6FB83397707A');
        $this->addSql('ALTER TABLE video_user DROP FOREIGN KEY FK_8A048B9529C1004E');
        $this->addSql('ALTER TABLE video_user DROP FOREIGN KEY FK_8A048B95A76ED395');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE pagos');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE video_categoria');
        $this->addSql('DROP TABLE video_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
