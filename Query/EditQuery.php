<?php

interface EditQuery {
    public function getParams(): array;
    public function __toString();
}