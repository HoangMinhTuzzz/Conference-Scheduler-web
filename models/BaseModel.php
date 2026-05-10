<?php
class BaseModel {
    protected $collection;

    // Tìm một bản ghi đầu tiên khớp điều kiện
    public function findOne($filter = []) {
        if (!$this->collection) return null;
        return $this->collection->findOne($filter);
    }

    // Các phương thức khác nếu cần...
}
