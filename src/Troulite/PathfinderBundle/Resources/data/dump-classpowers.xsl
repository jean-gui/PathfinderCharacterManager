<?xml version="1.0" encoding="utf-8" ?>

<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:x="http://www.w3.org/1999/xhtml"
    >


    <xsl:output method="text" encoding="utf-8" />


    <!-- MAIN -->
    <xsl:template match="/">
        <!-- csv headers -->
        <xsl:text>|name,description|</xsl:text>
        <xsl:text>&#xa;</xsl:text>

        <!-- find <h2>Class Features</h2> -->
        <xsl:apply-templates select="//x:h2
            [contains(normalize-space(.), 'Class Features')]
            [string-length(normalize-space(.)) = 14]
            "/>
    </xsl:template>

    <xsl:template match="x:h2">
        <xsl:variable name="hkey" select="."/>

        <!-- find all powers, 
             ie all <p> starting by <b>$POWER_NAME</b> and placed before next <h2/> -->
        <xsl:apply-templates 
            select="following-sibling::x:p[x:b][preceding-sibling::x:h2[1] = $hkey]"
            mode="title">
            <xsl:with-param name="hkey" select="$hkey"/>
        </xsl:apply-templates>
    </xsl:template>

    <xsl:template match="x:p" mode="title">
        <xsl:param    name="hkey"    />

        <xsl:text>|</xsl:text>

        <!-- extract power name -->
        <xsl:value-of select="normalize-space(x:b)"/>

        <xsl:text>|,|</xsl:text>

        <!-- extract power description -->
        <xsl:apply-templates select="." mode="content">
            <xsl:with-param name="hkey" select="$hkey"/>
        </xsl:apply-templates>

        <xsl:text>|&#xa;</xsl:text>
    </xsl:template>

    <xsl:template match="x:p" mode="content">
        <xsl:param    name="hkey"    />
        <!-- current power -->
        <xsl:variable name="current" select="."/>

        <!-- next power in the list -->
        <xsl:variable name="next"
            select="following-sibling::x:p
            [preceding-sibling::x:h2[1] = $hkey]
            [x:b]
            [1]"/>

        <!-- power description is between $current and $next -->
        <xsl:apply-templates select="descendant::text() | following-sibling::x:p
            [preceding-sibling::x:p = $current]
            [following-sibling::x:p = $next]
            "/>
    </xsl:template>

    <xsl:template match="text()" >
        <!-- normalize-space but keeping leading and trailing whitespace -->
        <xsl:value-of select="translate(normalize-space(concat('&#x7F;',.,'&#x7F;')),'&#x7F;','')"/>
    </xsl:template>


</xsl:stylesheet>
