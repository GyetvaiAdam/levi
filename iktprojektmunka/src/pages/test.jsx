import React, { useState, useEffect } from "react";
import { Typography, Card, CardBody, Radio, Button } from "@material-tailwind/react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import initemail from "./initemail.js";

export function Test() {
  const [questions, setQuestions] = useState([]);
  const [dimension, setDimension] = useState([]);
  const [responses, setResponses] = useState({});
  const navigate = useNavigate();

  useEffect(() => {
    const fetchQuestions = async () => {
      try {
        const response = await axios.get("http://localhost/levi/php/test_question_load.php");
        if (response.data && Array.isArray(response.data.questions) && Array.isArray(response.data.dimensions)) {
          setQuestions(response.data.questions);
          setDimension(response.data.dimensions);
        } else {
          console.error("Unexpected response format:", response.data);
        }
      } catch (error) {
        console.error("Error fetching questions:", error);
      }
    };

    fetchQuestions();
  }, []);

  const handleResponseChange = (questionIndex, value) => {
    setResponses((prevResponses) => ({
      ...prevResponses,
      [questionIndex]: { value: value, dimension: dimension[questionIndex] },
    }));
  };

  const handleUpdateAndSubmit = (responses, initemail) => {
    axios
      .post("http://localhost/levi/php/count.php", { email: initemail.email })
      .then(() => {
        return axios.post("http://localhost/levi/php/test_result.php", {
          responses,
          email: initemail.email,
        });
      })
      .then((submitResponse) => {
        console.log("Response from server:", submitResponse.data);
  
        if (submitResponse.data.success) {
          alert("Responses saved successfully!");
          navigate("/home");
        } else {
          alert("Failed to save responses.");
        }
      })
      .catch((error) => {
        console.error("Error occurred:", error);
        alert("An error occurred during the process. Please try again.");
      });
  };
  

  return (
    <div className="container mx-auto p-4">
      <Typography variant="h2" className="text-center my-4">
        Take the Test
      </Typography>
      {questions.length > 0 ? (
        questions.map((question, index) => (
          <Card key={index} className="my-4">
            <CardBody>
              <Typography variant="h5" className="mb-4">
                {question}
              </Typography>
              <div className="flex items-center justify-between">
                <Typography variant="paragraph" className="mr-4">
                  Disagree
                </Typography>
                <div className="flex justify-between w-full mx-4">
                  {Array.from({ length: 7 }, (_, i) => {
                    const value = -3 + i;
                    return (
                      <Radio
                        key={i}
                        id={`question-${index + 1}-answer-${value}`}
                        name={`question-${index}`}
                        value={value}
                        onChange={() => handleResponseChange(index, value)}
                      />
                    );
                  })}
                </div>
                <Typography variant="paragraph" className="ml-4">
                  Agree
                </Typography>
              </div>
            </CardBody>
          </Card>
        ))
      ) : (
        <Typography variant="paragraph" className="text-center my-4">
          Loading questions...
        </Typography>
      )}
      <div className="flex justify-center mt-8">
        <Button variant="filled" color="light-green" onClick={() => handleUpdateAndSubmit(responses, initemail)}>
          Send
        </Button>
      </div>
    </div>
  );
}

export default Test;
