import {useEffect, useState} from "@wordpress/element";
import {Button, TextControl} from "@wordpress/components";

type Props = {
	id: number,
	onChange: (id: number) => void
}

export default function SelectPoll(props:Props) {
	const {id} = props;

	const [tmpId, setTmpId] = useState(`${id}`);
	const [error, setError] = useState("");

	useEffect(() => {
		setTmpId(`${id}`);
	}, [id]);

	function handleSubmit(){
		const id = parseInt(tmpId);
		if(isNaN(id) || id < 1){
			setError("Id is not valid");
			return;
		}

		props.onChange(id);
	}

	useEffect(() => {
		if(error == "") return;
		const timeout = setTimeout(()=>{
			setError("");
		}, 3* 1000);
		return ()=> clearTimeout(timeout);
	}, [error]);

	return (
		<>
			<TextControl
				value={tmpId}
				onChange={setTmpId}
			/>
			<Button onClick={handleSubmit}>Übernehmen</Button>
			{error ? <p>{error}</p> : null}
		</>
	)
}
