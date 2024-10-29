<?php
 
namespace Reputationgenius;

class Comment
{
	protected $entry;
	protected $title;	
	protected $publish_date;
	protected $author;
	protected $portal;
	protected $stars;
	protected $provider;
	protected $n_rank;
	protected $comment_code;

	public function __construct($raw_data)
	{		
		foreach ($raw_data as $property => $value) {
			if (property_exists($this, $property)) {				
				$this->$property = $value;		
			}
		}		
	}


	public function get_code()
	{
		return $this->comment_code;
	}


	public function get_rank()
	{
		return $this->n_rank;
	}
	
	public function get_entry()
	{
		$this->entry = str_replace(['[+]', '[/+]'], ['<strong>'.__('I liked', 'bgrg').'</strong>: ', ''], $this->entry);
    	$this->entry = str_replace(['[-]', '[/-]'], ['<br/><strong>'.__('I disliked', 'bgrg').'</strong>: ', ''], $this->entry);
    	return $this->entry;  
	}

	public function get_publish_date()
	{		
		$month_name = __(date('M'), 'bgrg');
		return date('d', strtotime($this->publish_date)) . " $month_name " . date('Y', strtotime($this->publish_date));
	}

	public function get_author()
	{
		return $this->author;
	}

	public function get_provider_name()
	{
		switch($this->provider) {
	      case 'T':
	        return 'Tripadvisor';
	      case 'B':
	        return 'Booking';
	      case 'X':
	        return 'Expedia';
	    }
	}

	public function get_stars()
	{
		$stars = ((float)$this->n_rank * 5);
	    $stars = (int)$stars;
	    	    
	    $remainder = 5 - $stars;

	    return [
	        $stars,
	        $remainder
	    ];
	}

	public function get_title()
	{
		$this->title = str_replace(['«', '»'], '', $this->title);
	    
    	return $this->title;
	}
}