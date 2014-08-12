<?xml version="1.0" encoding="utf-8" ?>

<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:p="urn:pathfinderDb"
    >


    <xsl:output method="text" encoding="utf-8" />


    <xsl:variable name="smallcase" select="'abcdefghijklmnopqrstuvwxyz'" />
    <xsl:variable name="uppercase" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'" />

    <!-- MAIN -->
    <xsl:template match="/">
        <xsl:text>name_fr,description_fr,benefit_fr,source_xml</xsl:text>
        <xsl:text>&#xa;</xsl:text>
        <xsl:apply-templates select="p:dataSet/p:feats/p:feat"/>
    </xsl:template>

    <xsl:template match="p:feat">
        <xsl:text>|</xsl:text>
        <xsl:value-of select="@name"/>
        <xsl:text>|,|</xsl:text>
        <xsl:value-of select="p:description"/>
        <xsl:text>|,|</xsl:text>
        <xsl:value-of select="p:benefit"/>
        <xsl:text>|,|</xsl:text>
        <xsl:apply-templates select="p:source"/>
        <xsl:text>|&#xa;</xsl:text>
    </xsl:template>
    

    <xsl:template match="p:source">
        <xsl:value-of select="translate(@id, $smallcase, $uppercase)"/>
    </xsl:template>
    

</xsl:stylesheet>
