<?php
function getClassByProfitRate(float $rate): string {
    if($rate < 1) return 'profit1';
    if($rate <= 1.5) return 'profit2';
    if($rate <= 2) return 'profit3';
    if($rate <= 5) return 'profit4';
    if($rate <= 10) return 'profit5';
}