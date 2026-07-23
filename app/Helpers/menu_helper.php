<?php

if (!function_exists('get_dynamic_menus')) {
    function get_dynamic_menus()
    {
        $session = session();
        $id_user_group = $session->get('id_user_group');
        
        if (!$id_user_group) {
            return [];
        }
        
        $db = \Config\Database::connect();
        
        // If Super Admin, get all menus
        if ($id_user_group == 1) {
            $menus = $db->table('c_menus')
                      ->select('c_menus.*, 0 as target_blank')
                      ->where('status', 1)
                      ->orderBy('position', 'ASC')
                      ->get()
                      ->getResultArray();
        } else {
            // Get menus for this group
            $menus = $db->table('c_menus m')
                      ->select('m.id, m.id_parent, m.name, m.url, m.position, m.icon, m.status, 0 as target_blank')
                      ->join('c_menus_privileges p', 'p.id_menu = m.id')
                      ->where('p.id_user_group', $id_user_group)
                      ->where('m.status', 1)
                      ->orderBy('m.position', 'ASC')
                      ->get()
                      ->getResultArray();
        }

        return build_menu_tree($menus);
    }
}

if (!function_exists('build_menu_tree')) {
    function build_menu_tree(array $elements, $parentId = null) {
        $branch = array();
        foreach ($elements as $element) {
            // In MySQL, root nodes might have id_parent as NULL or 0.
            // When building root level (parentId is null), we treat id_parent = null, empty string, or 0 as matches.
            $elementParentId = $element['id_parent'];
            $isMatch = false;
            
            if ($parentId === null) {
                if ($elementParentId === null || $elementParentId === '' || $elementParentId == 0) {
                    $isMatch = true;
                }
            } else {
                if ($elementParentId == $parentId) {
                    $isMatch = true;
                }
            }

            if ($isMatch) {
                $children = build_menu_tree($elements, $element['id']);
                if ($children) {
                    $element['submenus'] = $children;
                } else {
                    $element['submenus'] = [];
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
}
