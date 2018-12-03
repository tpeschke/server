<?php
    // GET sql queries
    function get_board($id) {
        return "select lngStepId, strStepName from tblBoardSteps where lngBoardId = $id;";
    };
    function get_all_boards($id) {
        return "select lngBoardId, strBoardName from tblBoards where lngOwnerId = $id;";
    };
    function get_step($id) {
        return "select lngStepId, strStepName, txtContent from tblBoardSteps where lngStepId = $id;";
    };
    function get_hash($id) {
        return "select strBoardHash from tblBoards where lngBoardId = $id;";
    };
    // PUT sql queries
    function update_steps($name, $content, $id) {
        return "update tblBoardSteps set strStepName ='" . $name . "', txtContent ='" . $content . "' where lngStepId = $id; ";
    };
    // POST sql queries
    function add_step($name, $content, $stepNum, $board) {
        return "insert into tblBoardSteps (strStepName, txtContent, intStepNum, lngBoardId) values ('" . $name . "', '" . $content ."', $stepNum, $board); ";
    };