
CREATE TABLE `c_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=aktif, 0=tidak aktif',
  `target_blank` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `id_parent` (`id_parent`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;               

CREATE TABLE `c_menus_privileges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user_group` int(10) unsigned NOT NULL,
  `id_menu` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `id_user_group` (`id_user_group`) USING BTREE,
  KEY `id_menu` (`id_menu`) USING BTREE,
  CONSTRAINT `c_menus_privileges_ibfk_1` FOREIGN KEY (`id_user_group`) REFERENCES `c_user_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `c_menus_privileges_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `c_menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;    

CREATE TABLE `c_user_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=aktif, 0=tidak aktif',
  `created_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'id_user',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL COMMENT 'id_user',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

ini ada tambahan nah ini gunanya buat apa?

Tolong analisis kembali project CodeIgniter 4 yang sedang saya kerjakan. Kamu sudah bisa membaca struktur project dan source code yang ada.

Ada beberapa perubahan pada desain database dan alur sistem yang harus disesuaikan.

PERUBAHAN DATABASE

1. Ditambahkan sistem Role Based Access Control (RBAC):
- c_user_group
- c_menus
- c_menus_privileges

Yang saya minta:

1. Analisis seluruh project apakah ada Model, Controller, Migration, Seeder, Route, atau View yang harus disesuaikan dengan perubahan ini.

2. Berikan daftar file yang perlu diubah beserta alasannya (jika ada)

3. Jangan langsung mengubah seluruh project. Analisis dahulu dan jelaskan perubahan yang diperlukan satu per satu.

