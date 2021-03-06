<?php
/**
 * Created by PhpStorm.
 * User: lingjiang
 * Date: 2016/6/6
 * Time: 14:13
 */
namespace app\admin\model;
class CardModel{
    private  $m;
    public function __construct(){
        $this->m=M('card_list');
    }
    //获取卡密信息
    public function get_card_info($id){
        return $this->m->where(['id'=>$id])->find();
    }
    //更新卡密
    public function card_update($post){
        $id=$category=$num=$sec=$stat=null;
        extract($post);
        $data=[
            'id'=>!empty($id)?$id:'',
            'category'=>!empty($category)?$category:'',
            'num'=>!empty($num)?$num:'',
            'sec'=>!empty($sec)?$sec:'',
            'stat'=>!empty($stat)?$stat:''
        ];
        if(empty($id)){
            $res=$this->m->add($data);
        }else{
            $res=$this->m->save($data);
        }
        return $res;
    }
    //获取卡密列表
    public function get_cards($post){
        $sql = "SELECT SQL_CALC_FOUND_ROWS  c.*,cate.title,u.username,u.type user_type
        FROM  sp_card_list c
        LEFT JOIN sp_card_category cate ON cate.id=c.category
        LEFT JOIN sp_users u on u.id=c.uid
        WHERE  c.stat != -1 " . $post->wheresql .
            " ORDER BY c.id desc " . $post->limitData;

        $sql_count = "SELECT FOUND_ROWS() as num";
        $act_info = $this->m->query($sql);
        $num = $this->m->query($sql_count);

        $rt["data"] = $act_info;
        $rt["count"] = $num[0]["num"];
        return $rt;
    }
    public function card_del($id){
        return $this->m->where(['id'=>$id])->delete();
    }

    public function card_import($data){
        $res=$this->m->addAll($data);
        return $res;
    }

    public function category_detail($id){
        $m_category = M('card_category','sp_');
        return $m_category->where(['id'=>$id])->find();
    }

    public function category_list_simple(){
        $m_category = M('card_category','sp_');
        return $m_category->field('id,title')->where(['status'=>['neq',-1]])->select();
    }

    public function category_list($post){
        $sql = 'SELECT SQL_CALC_FOUND_ROWS
    cate.*, g.`name` goods_name,
    COUNT(card.id) total,
    COUNT(card.id) - SUM(card.used) remain
FROM
    sp_card_category cate
LEFT JOIN sp_card_list card ON card.category = cate.id
LEFT JOIN sp_goods g ON g.reward_data = cate.id AND g.reward_type = 1
WHERE
    cate.`status` <> - 1
GROUP BY
    cate.id'.$post->limitData;
        $sql_count = "SELECT FOUND_ROWS() as num";
        $info = $this->m->query($sql);
        $num = $this->m->query($sql_count);

        $rt["data"] = $info;
        $rt["count"] = $num[0]["num"];
        return $rt;
    }

    public function category_update($post)
    {
        $m_category = M('card_category','sp_');
        $id=$title=$money=$sort=$uid=$status=null;
        extract($post);
        $data=[
            'id'=>!empty($id)?$id:'',
            'title'=>!empty($title)?$title:'',
            'money'=>!empty($money)?$money:'',
            'number'=>!empty($number)?$number:'',
            'sort'=>!empty($sort)?$sort:'',
            'status'=>!empty($status)?$status:''
        ];
        if(empty($id)){
            unset($data['id']);
            $res=$m_category->add($data);
        }else{
            $res=$m_category->save($data);
        }
        return $res;
    }

    public function category_del($id){
        $m_category = M('card_category','sp_');
        return $m_category->where(['id'=>$id])->data(['status'=>-1])->save();
    }
}