<?php
class Markdown{
    public function text(string $markdownText): string
    {
        $lines = $this->textlines($markdownText);
        $htmlCode = "";
        // convert to lines to html code
        foreach($lines as $line){
            $htmlCode .= $this->convertLine($line);
        }

        return $htmlCode;
    }

    protected function textlines(string $markdownText): array
    {
        //standardize line breaks
        $markdownText = str_replace(array("\r\n", "\r"), "\n", $markdownText);

        // remove surrounding line breaks
        $markdownText = trim($markdownText, "\n");

        // split text into lines
        $lines = explode("\n", $markdownText);

        return $lines;
    }

    protected function convertLine(string $line): string
    {
        if(empty($line)){
            return '';
        }
        if($line[0] == "#"){
            return $this->convertHeader($line);
        }
        else{
            return $this->convertParagraph($line);
        }
    }

    protected function convertHeader(string $line): string
    {
        $headerType = 0;
        // Get header type
        while($line[$headerType] == "#"){
            $headerType++;
        }
        
        $line = substr($line, $headerType);

        $header = "<h".$headerType.">";
        $header .= $this->getHtmlTextWithLinks($line);
        $header .= "</h".$headerType.">";
        return $header;
    } 

    protected function convertParagraph(string $line): string
    {
        $paragraph = "<p>";
        $paragraph .= $this->getHtmlTextWithLinks($line);
        $paragraph .= "</p>";
        return $paragraph;
    }
  
    protected function getLinksOnline(string $line): array
    {
        $pattern = "/\[.+?\]\(.*?\)/";
        preg_match_all($pattern, $line, $matches, PREG_OFFSET_CAPTURE);
        $links = [];
        foreach($matches[0] as $key=>$match){
            if(strpos(substr($match[0], 1), "[") !== false){
                $pos = strpos(substr($match[0], 1), '[');
                $match[0] = substr($match[0], $pos+1);
            }
            $position = strpos($match[0], '](');
            $link = '<a href="'.
                substr($match[0], $position+2, -1) . '">'.
                substr($match[0], 1, $position-1).
                '</a>';
                
            $links[] = ['position' => $match[1], 'count' => strlen($match[0]), 'link' => $link];

        }
        return $links;
    }
    
    //Get htlm text with link inside the html block
    protected function getHtmlTextWithLinks(string $line): string
    {
        // if this text content link get them
        $links = $this->getLinksOnline($line);
        $textHtml = "";
        $pointer = 0;
        if(!empty($links)){
            foreach($links as $link){
                $textHtml .= substr($line, $pointer, $link['position'])
                                . $link['link'];
                $pointer = $link['position'] + $link['count'];
            }
            $textHtml .= substr($line, $pointer);
        }
        else{
            $textHtml .= $line;
        }

        return $textHtml;
    }
}