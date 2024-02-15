<?php
namespace ITL\Serializer;

class UserStoreSerializer {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Serialize the input data
     * @return $model
     */
    public function getModel() {
        // Process and serialize $this->data to create the model
        $model = array(
            'id' => $this->data['id'],
            'store_url' => $this->data['store_url'],
            'access_token' => $this->data['access_token']
        );

        // Return the serialized model
        return $model;
    }
}