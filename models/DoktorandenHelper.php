<?php
class DoktorandenHelper
{
    public static function getFilterQuery($year)
    {
        $pyear = $year - 1;

        return "(
                promotionsende_jahr IS NULL
                OR (
                    promotionsende_jahr = $year
                    AND promotionsende_monat < 12
                )
                OR (
                    promotionsende_jahr = $pyear
                    AND promotionsende_monat = 12
                )
            ) AND (
                (
                    promotionsbeginn_jahr = $year
                    AND promotionsbeginn_monat < 12
                )
                OR (
                    promotionsbeginn_jahr <= $pyear
                )
            )";
    }
}
