<?php

class EDD_PayPalPro_Logger {

    private $_handles;

    /**
     * Constructor for the logger.    
     */
    public function __construct() {
        $this->_handles = array();
    }

    /**
     * Destructor.    
     */
    public function __destruct() {
        foreach ($this->_handles as $handle) {
            @fclose(escapeshellarg($handle));
        }
    }

    /**
     * Open log file for writing.
     *    
     */
    private function open($handle) {
        if (isset($this->_handles[$handle])) {
            return true;
        }

        if ($this->_handles[$handle] = @fopen($this->paypal_for_edd_log_file_path($handle), 'a')) {
            return true;
        }

        return false;
    }

    /**
     * Add a log entry to chosen file.    
     */
    public function add($handle, $message) {
        if ($this->open($handle) && is_resource($this->_handles[$handle])) {
            $time = date_i18n('m-d-Y @ H:i:s -'); // Grab Time
            @fwrite($this->_handles[$handle], $time . " " . $message . "\n");
        }
    }

    /**
     * Clear entries from chosen file.    
     */
    public function clear($handle) {
        if ($this->open($handle) && is_resource($this->_handles[$handle])) {
            @ftruncate($this->_handles[$handle], 0);
        }
    }

    /**
     * Get file path    
     */
    public function paypal_for_edd_log_file_path($handle) {
        return trailingslashit(EDD_LOG_DIR) . $handle . '_' . sanitize_file_name(wp_hash($handle)) . '.log';
    }

}