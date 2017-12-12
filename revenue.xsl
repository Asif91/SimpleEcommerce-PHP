<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"> 
    <xsl:output method="html"/>
    <xsl:template match="/">
        
        <table class="gradienttable" >
            <thead>
                <tr>
                    <th>
					<p>
                        Item No
                    </p>
					</th>
                    <th>
					<p>
                        Name
                    </p>
					</th>
                    <th>
					<p>
                        Seller ID
                    </p>
					</th>
                    <th>
					<p>
                        Current Status
                    </p>
					</th>
                    <th>
					<p>
                        Category
                    </p>
					</th>
                    <th>
					<p>
                        Reserve Price
                    </p>
					</th>
                    <th>
					<p>
                        Start Price
                    </p>
					</th>
                    <th>
					<p>
                        Buy Now Price
                    </p>
					</th>
                    <th>
					<p>
                        Bidder ID
                    </p>
					</th>
                    <th>
					<p>
                        Bid Price
                    </p>
					</th>
                    <th>
					<p>
                        Start Date 
                    </p>
					</th>
                    <th>
					<p>
                        Start Time
                    </p>
					</th>

                </tr>
            </thead>
            <xsl:for-each select="items/item">
                <xsl:if test="not(status = 'in_progress')">      
                    <tr>   
                        <td>
						<p>
                            <xsl:value-of select="itemnum"/>
                        </p>
						</td>
                    
                        <td>
						<p>
                            <xsl:value-of select="itemname"/>
                        </p>
						</td>
                        
                        <td>
						<p>
                            <xsl:value-of select="customerid"/>
                        </p>
						</td>
                    
                        <td>
						<p>
                            <xsl:value-of select="status"/>
                        </p>
						</td>
                        
                        <td>
						<p>
                            <xsl:value-of select="category"/>
                        </p>
						</td>
                        
                        <td>
						<p>
                            <xsl:value-of select="reserveprice"/>
                        </p>
						</td>
                        
                        <td>
						<p>
                            <xsl:value-of select="startprice"/>
                        </p>
						</td>
                        
                        <td>
                        <p>
							<xsl:value-of select="buyprice"/>
                        </p>
						</td>
                        
                        <td>
						<p>
                            <xsl:choose >
                                <xsl:when test="count(bidderid) = 0">
                                    None
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:value-of select="bidderid"/>
                                </xsl:otherwise>
                            </xsl:choose>
						</p>
                        </td>
                        <td>
						<p>
                            <xsl:value-of select="bidprice"/>
                        </p>
						</td>
                        
                        <td>
						<p>
                            <xsl:value-of select="startdate"/>
                        </p>
						</td>
                        
                        <td>
						<p>
                            <xsl:value-of select="timestamp"/>
                        </p>
						</td>

                    </tr>
                    <br/>
                    <br/>
                </xsl:if>
            </xsl:for-each>
        </table>
			<span class="span1">Total Items Failed : <xsl:value-of select="count(items/item[status='failed'])"/></span> 
   			<span class="span1">Total Items Sold : <xsl:value-of select="count(items/item[status='sold'])"/></span> 
			<span class="span1">Revenue:<xsl:value-of select=" sum(items/item[status='sold']/bidprice) * 3 div 100 + sum(items/item[status='failed']/reserveprice) div 100 "/></span>
    </xsl:template>
</xsl:stylesheet>
