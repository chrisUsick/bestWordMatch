<?xml version="1.0"?>
<x:stylesheet version="1.0"
 xmlns:x="http://www.w3.org/1999/XSL/Transform">
<x:template match="/">
  <cards>
    <x:for-each select="ul/li">
      <card>
        <word>
          <x:value-of select="b"/>
        </word>
        <description>
          <x:if test="i">
            <x:value-of select="i/text()"/>
          </x:if>
          <x:value-of select="substring(./text(), 4)"/>
        </description>
      </card>
    </x:for-each>
  </cards>
</x:template>

</x:stylesheet>
