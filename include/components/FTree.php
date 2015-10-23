<?php

/**
 * 通用的树型类，可以生成任何树型结构
 *
 * @author jinglin
 */
class FTree {

    /**
     * 生成树型结构所需要的2维数组
     * @var array
     */
    var $arr = array();
    /**
     * 生成树型结构所需修饰符号，可以换成图片
     * @var array
     */
    //var $icon = array('│', '├', '└');
    var $icon = array('', '', '');
    /**
     * @access private
     */
    var $ret = '';

    /**
     * 构造函数，初始化类
     * @param array 2维数组，例如：
     * array(
     *      1 => array('id'=>'1','parentId'=>0,'name'=>'一级栏目一'),
     *      2 => array('id'=>'2','parentId'=>0,'name'=>'一级栏目二'),
     *      3 => array('id'=>'3','parentId'=>1,'name'=>'二级栏目一'),
     *      4 => array('id'=>'4','parentId'=>1,'name'=>'二级栏目二'),
     *      5 => array('id'=>'5','parentId'=>2,'name'=>'二级栏目三'),
     *      6 => array('id'=>'6','parentId'=>3,'name'=>'三级栏目一'),
     *      7 => array('id'=>'7','parentId'=>3,'name'=>'三级栏目二')
     *      )
     */
    function FTree($arr=array()) {
        $this->arr = $arr;
        $this->ret = '';
        return is_array($arr);
    }

    /**
     * 得到父级数组
     * @param int
     * @return array
     */
    function get_parent($myid) {
        $newarr = array();
        if (!isset($this->arr[$myid]))
            return false;
        $pid = $this->arr[$myid]['parent_id'];
        $pid = $this->arr[$pid]['parent_id'];
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a['parent_id'] == $pid)
                    $newarr[$id] = $a;
            }
        }
        return $newarr;
    }

    /**
     * 得到子级数组
     * @param int
     * @return array
     */
    function get_child($myid) {
        $a = $newarr = array();
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a['parent_id'] == $myid)
                    $newarr[$a['id']] = $a;
            }
        }
        return $newarr ? $newarr : false;
    }

    /**
     * 得到当前位置数组
     * @param int
     * @return array
     */
    function get_pos($myid, &$newarr) {
        $a = array();
        if (!isset($this->arr[$myid]))
            return false;
        $newarr[] = $this->arr[$myid];
        $pid = $this->arr[$myid]['parent_id'];
        if (isset($this->arr[$pid])) {
            $this->get_pos($pid, $newarr);
        }
        if (is_array($newarr)) {
            krsort($newarr);
            foreach ($newarr as $v) {
                $a[$v['id']] = $v;
            }
        }
        return $a;
    }

    function have($list, $item) {
        return(strpos(',,' . $list . ',', ',' . $item . ','));
    }

    function getArray($myid=0, $sid=0, $adds='') {
        $number = 1;
        $child = $this->get_child($myid);
        /*print_r($child);
        exit;*/
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $a) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';
                @extract($a);
                $a['tag_name'] = $spacer . '' . $a['tag_name'];
                $this->ret[$a['id']] = $a;
               // $fd = $adds . $k . '&nbsp;';
                $fd = $adds . $k ;
                $this->getArray($id, $sid, $fd);
                $number++;
            }
        }
        return $this->ret;
    }

}

?>