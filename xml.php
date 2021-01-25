<?php
header('Content-Type: application/xml');
$xmlstr = <<<XML
<?xml version='1.0' standalone='yes'?>
<node>
 <test>
  <invalid>Some invalid character: 谷���新道, ひば���ヶ丘２丁���, ひばりヶ���, 東久留米市 (Higashikurume)</invalid>
  <invalid>Some invalid character: \u0026 \u0000-\u0008 0x21 0x12 0x0020  U+0000 [#x7F-#x84]  #x0009</invalid>
  <invalid>Some invalid character: 0x21 0x12 0x0020</invalid>
  <invalid>Some invalid character: U+0000 [#x7F-#x84] #x0009</invalid>
  <invalid>Some invalid character: \t \r \n \b</invalid>
 </test>
</node>
XML;

print((new SimpleXMLElement($xmlstr))->asXML());