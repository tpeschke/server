<?php
    // GET sql queries
    function get_board($id) {
        return "select lngStepId, strStepName from tblBoardSteps where lngBoardId = $id";
    };
    function get_all_boards($id) {
        return "select lngBoardId, strBoardName from tblBoards where lngOwnerId = $id";
    };
    function get_step($id) {
        return "select lngStepId, strStepName, txtContent from tblBoardSteps where lngStepId = $id";
    };
    // PUT sql queries
    function update_steps($name, $content, $id) {
        return "update tblBoardSteps set strStepName = $name, txtContent = $content where lngStepId = $id;";
    };